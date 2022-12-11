/****** Object:  Table [dbo].[pedimentosComplementarios]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[pedimentosComplementarios](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[clave] [varchar](5) NULL,
	[tipocambio] [decimal](18, 2) NULL,
	[curpImportador] [varchar](18) NULL,
	[rfcImportador] [varchar](13) NULL,
	[razonsocial] [varchar](120) NULL,
	[curpApoderado] [varchar](18) NULL,
	[rfcAgente] [varchar](13) NULL,
	[pedimento_id] [int] NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_pedimentosComplementarios] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
