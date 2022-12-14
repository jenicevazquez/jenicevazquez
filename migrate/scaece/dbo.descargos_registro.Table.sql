/****** Object:  Table [dbo].[descargos_registro]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[descargos_registro](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[descargos_id] [int] NULL,
	[tipo] [varchar](2) NULL,
	[fraccion] [varchar](8) NULL,
	[valorPesos] [numeric](14, 2) NULL,
	[identificador] [varchar](1) NULL,
	[licencia] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
