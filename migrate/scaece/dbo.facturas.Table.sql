/****** Object:  Table [dbo].[facturas]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[facturas](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[fecha] [date] NULL,
	[numero] [varchar](50) NULL,
	[termino] [varchar](5) NULL,
	[moneda] [varchar](5) NULL,
	[valordolares] [decimal](18, 2) NULL,
	[valormoneda] [decimal](18, 2) NULL,
	[proveedor_id] [int] NULL,
	[pedimento_id] [int] NULL,
	[idfiscal] [varchar](18) NULL,
	[proveedor] [varchar](120) NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_facturas] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
